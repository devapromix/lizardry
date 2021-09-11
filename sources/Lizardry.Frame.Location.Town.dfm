object FrameTown: TFrameTown
  Left = 0
  Top = 0
  Width = 897
  Height = 474
  Font.Charset = RUSSIAN_CHARSET
  Font.Color = clWindowText
  Font.Height = -19
  Font.Name = 'Courier New'
  Font.Style = []
  ParentFont = False
  TabOrder = 0
  object Panel7: TPanel
    Left = 616
    Top = 0
    Width = 281
    Height = 474
    Align = alRight
    BevelOuter = bvNone
    Color = clGreen
    ParentBackground = False
    TabOrder = 0
    object Panel8: TPanel
      Tag = 1
      Left = 0
      Top = 0
      Width = 281
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = 'CharName'
      ParentBackground = False
      TabOrder = 0
      object bbLogout: TSpeedButton
        Left = 192
        Top = 1
        Width = 88
        Height = 23
        Cursor = crHandPoint
        Align = alRight
        Caption = #1042#1099#1093#1086#1076
        Flat = True
        OnClick = SpeedButton1Click
        ExplicitTop = 0
      end
    end
    object Panel12: TPanel
      Tag = 5
      Left = 0
      Top = 200
      Width = 281
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1047#1086#1083#1086#1090#1086' 0'
      ParentBackground = False
      TabOrder = 1
    end
    object Panel13: TPanel
      Tag = 5
      Left = 0
      Top = 50
      Width = 281
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1054#1087#1099#1090': 0/100'
      ParentBackground = False
      TabOrder = 2
    end
    object Panel14: TPanel
      Tag = 5
      Left = 0
      Top = 75
      Width = 281
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1047#1076#1086#1088#1086#1074#1100#1077': 30/30'
      ParentBackground = False
      TabOrder = 3
    end
    object Panel15: TPanel
      Tag = 5
      Left = 0
      Top = 175
      Width = 281
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1055#1088#1086#1074#1080#1079#1080#1103' 7/7'
      ParentBackground = False
      TabOrder = 4
    end
    object Panel16: TPanel
      Tag = 5
      Left = 0
      Top = 100
      Width = 281
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1052#1072#1085#1072': 20/20'
      ParentBackground = False
      TabOrder = 5
    end
    object Panel11: TPanel
      Tag = 4
      Left = 0
      Top = 25
      Width = 281
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1059#1088#1086#1074#1077#1085#1100': 1'
      ParentBackground = False
      TabOrder = 6
    end
    object Panel17: TPanel
      Tag = 5
      Left = 0
      Top = 125
      Width = 281
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1059#1088#1086#1085': 2-3'
      ParentBackground = False
      TabOrder = 7
    end
    object Panel18: TPanel
      Tag = 5
      Left = 0
      Top = 150
      Width = 281
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1041#1088#1086#1085#1103': 0'
      ParentBackground = False
      TabOrder = 8
    end
  end
  object Panel1: TPanel
    Left = 0
    Top = 0
    Width = 281
    Height = 474
    Align = alLeft
    BevelOuter = bvNone
    Color = clGreen
    ParentBackground = False
    TabOrder = 1
    object Panel2: TPanel
      Tag = 1
      Left = 0
      Top = 0
      Width = 281
      Height = 25
      Cursor = crHandPoint
      Align = alTop
      Alignment = taLeftJustify
      Caption = '111111'
      ParentBackground = False
      TabOrder = 0
      Visible = False
      OnClick = LeftPanelClick
    end
    object Panel3: TPanel
      Tag = 2
      Left = 0
      Top = 25
      Width = 281
      Height = 25
      Cursor = crHandPoint
      Align = alTop
      Alignment = taLeftJustify
      Caption = '111111'
      ParentBackground = False
      TabOrder = 1
      Visible = False
      OnClick = LeftPanelClick
    end
    object Panel4: TPanel
      Tag = 3
      Left = 0
      Top = 50
      Width = 281
      Height = 25
      Cursor = crHandPoint
      Align = alTop
      Alignment = taLeftJustify
      Caption = '111111'
      ParentBackground = False
      TabOrder = 2
      Visible = False
      OnClick = LeftPanelClick
    end
    object Panel5: TPanel
      Tag = 4
      Left = 0
      Top = 75
      Width = 281
      Height = 25
      Cursor = crHandPoint
      Align = alTop
      Alignment = taLeftJustify
      Caption = '111111'
      ParentBackground = False
      TabOrder = 3
      Visible = False
      OnClick = LeftPanelClick
    end
    object Panel6: TPanel
      Tag = 5
      Left = 0
      Top = 100
      Width = 281
      Height = 25
      Cursor = crHandPoint
      Align = alTop
      Alignment = taLeftJustify
      Caption = '111111'
      ParentBackground = False
      TabOrder = 4
      Visible = False
      OnClick = LeftPanelClick
    end
  end
  object Panel9: TPanel
    Left = 281
    Top = 0
    Width = 335
    Height = 474
    Align = alClient
    BevelOuter = bvNone
    TabOrder = 2
    object Panel10: TPanel
      Tag = 5
      Left = 0
      Top = 0
      Width = 335
      Height = 25
      Align = alTop
      Caption = 'Location name'
      ParentBackground = False
      TabOrder = 0
    end
    object FramePanel: TPanel
      Left = 0
      Top = 274
      Width = 335
      Height = 200
      Align = alBottom
      TabOrder = 1
      inline FrameBank1: TFrameBank
        Left = 1
        Top = 1
        Width = 333
        Height = 198
        Align = alClient
        Font.Charset = RUSSIAN_CHARSET
        Font.Color = clWindowText
        Font.Height = -19
        Font.Name = 'Courier New'
        Font.Style = []
        ParentFont = False
        TabOrder = 0
        ExplicitLeft = 1
        ExplicitTop = 1
        ExplicitWidth = 333
        ExplicitHeight = 198
      end
      inline FrameDefault1: TFrameDefault
        Left = 1
        Top = 1
        Width = 333
        Height = 198
        Align = alClient
        TabOrder = 1
        ExplicitLeft = 1
        ExplicitTop = 1
        ExplicitWidth = 333
        ExplicitHeight = 198
      end
      inline FrameTavern1: TFrameTavern
        Left = 1
        Top = 1
        Width = 333
        Height = 198
        Align = alClient
        Font.Charset = RUSSIAN_CHARSET
        Font.Color = clWindowText
        Font.Height = -19
        Font.Name = 'Courier New'
        Font.Style = []
        ParentFont = False
        TabOrder = 2
        ExplicitLeft = 1
        ExplicitTop = 1
        ExplicitWidth = 333
        ExplicitHeight = 198
      end
      inline FrameOutlands1: TFrameOutlands
        Left = 1
        Top = 1
        Width = 333
        Height = 198
        Align = alClient
        TabOrder = 3
        ExplicitLeft = 1
        ExplicitTop = 1
        ExplicitWidth = 333
        ExplicitHeight = 198
      end
    end
    object Panel19: TPanel
      Left = 0
      Top = 25
      Width = 335
      Height = 249
      Align = alClient
      TabOrder = 2
      inline FrameBattle1: TFrameBattle
        Left = 1
        Top = 1
        Width = 333
        Height = 247
        Align = alClient
        Font.Charset = RUSSIAN_CHARSET
        Font.Color = clWindowText
        Font.Height = -19
        Font.Name = 'Courier New'
        Font.Style = []
        ParentFont = False
        TabOrder = 0
        ExplicitLeft = 1
        ExplicitTop = 1
        ExplicitWidth = 333
        ExplicitHeight = 247
        inherited Image2: TImage
          OnClick = nil
        end
      end
      inline FrameInfo1: TFrameInfo
        Left = 1
        Top = 1
        Width = 333
        Height = 247
        Align = alClient
        TabOrder = 1
        ExplicitLeft = 1
        ExplicitTop = 1
        ExplicitWidth = 333
        ExplicitHeight = 247
        inherited StaticText2: TStaticText
          Top = 113
          Width = 333
          ExplicitTop = 113
          ExplicitWidth = 333
        end
        inherited StaticText1: TStaticText
          Width = 333
          Height = 113
          ExplicitWidth = 333
          ExplicitHeight = 113
        end
      end
      inline FrameLoot1: TFrameLoot
        Left = -374
        Top = -212
        Width = 709
        Height = 461
        TabOrder = 2
        ExplicitLeft = -374
        ExplicitTop = -212
      end
    end
  end
end
