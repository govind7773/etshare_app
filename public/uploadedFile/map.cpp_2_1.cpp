#include<iostream>
#include<bits/stdc++.h>
using namespace std;
int main()
{
       map<int,string>mp;
       mp[2]="govind";
       mp[1]="banna";
       mp[3]="hello";

     // cout<<mp.size();
     pair<int,string>p;
     p={5,"gondj"};
     mp.insert(p);
map<int,string>::iterator it;
mp.insert({4,"heft"});
//mp.insert({4,8});
//mp[4]++;
//mp[4]=mp[2]+3;
  // if(mp.find())!=mp.end())s
      // cout<<"YES";
   //  cout<<t<<endl;
          for( auto &i : mp)
              cout<<i.first<<" "<<i.second<<endl;

       for( it=mp.begin();it!=mp.end();it++){
              cout<<(*it).first<<" "<<(*it).second<<" ";}
       return 0;
}
